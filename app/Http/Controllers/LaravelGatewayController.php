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
        $path = $this->translateRouteFromConfig($service, $path);

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

    /**
     * Checks if there are any route overrides defined for this path and
     * returns the overridden route. If the path has no overrides, then the
     * provided path will be returned.
     *
     * @param string $path
     * @return string
     */
    private function translateRouteFromConfig(string $serviceName, string $path): string
    {
        $overrides = config('routes.overrides');
        if (array_key_exists($serviceName, $overrides)) {
            if (array_key_exists($path, $overrides[$serviceName])) {
                $path = $overrides[$serviceName][$path];
            }
        }
        if ($path === '/') {
            $path = '';
        }
        return $path;
    }
}
