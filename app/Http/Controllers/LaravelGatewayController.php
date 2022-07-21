<?php

namespace App\Http\Controllers;

use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LaravelGatewayController extends Controller
{
    public function get(Request $request, $slug = null): \Illuminate\Http\Response
    {
        return $this->handleRequest($request, 'get', $slug);
    }

    public function post(Request $request, $slug = null): \Illuminate\Http\Response
    {
        return $this->handleRequest($request, 'post', $slug);
    }

    public function put(Request $request, $slug = null): \Illuminate\Http\Response
    {
        return $this->handleRequest($request, 'put', $slug);
    }

    public function patch(Request $request, $slug = null): \Illuminate\Http\Response
    {
        return $this->handleRequest($request, 'patch', $slug);
    }

    public function delete(Request $request, $slug = null): \Illuminate\Http\Response
    {

        return $this->handleRequest($request, 'delete', $slug);
    }

    public function options(Request $request, $slug = null): \Illuminate\Http\Response
    {

        return $this->handleRequest($request, 'options', $slug);
    }

    private function handleRequest(Request $request, $method, $slug = null): \Illuminate\Http\Response
    {
        if (empty($slug)) {
            abort(404);
        }
        $slugParts = explode('/', $slug);
        if (count($slugParts) <= 0) {
            abort(404);
        }
        $service = $slugParts[0];
        $path = implode('/', array_slice($slugParts, 1));

        $urlProtocol = config('laravel-gateway.protocol');
        $urlTopLevelDomain = config('laravel-gateway.tld');

        $domain = "$urlProtocol://$service.$urlTopLevelDomain";

        $requestHeaders = [];
        $contentType = null;
        foreach ($request->header() as $key => $value) {
            if (strtolower($key) === 'host') {
                continue;
            }
            if (strtolower($key) === 'content-length') {
                continue;
            }
            if (strtolower($key) === 'content-type') {
                $contentType = $value[0];
                continue;
            }
            $requestHeaders[$key] = $value[0];
        }

        $proxyRequest = Http::withHeaders($requestHeaders);
        $content = $request->getContent();
        if (!empty($content)) {
            $proxyRequest->withBody($content, $contentType);
        }

        /** @var Response $response */
        $response = $proxyRequest->$method("$domain/$path", $request->query());

        $responseHeaders = [];
        foreach ($response->headers() as $key => $value) {
            $responseHeaders[$key] = $value[0];
        }

        return response($response->body(), $response->status(), $responseHeaders);
    }
}
