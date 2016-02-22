<?php

namespace Framework\Http;


class Request
{
    private $uri;
    private $post = [];
    private $get  = [];
    private $session;
    private $sessionId;
    private $requestType;

    public function __construct()
    { }

    public function getUri()
    {
        return $this->uri;
    }

    public function setUri($uri)
    {
        $this->uri = $uri;
    }

    public function getPost()
    {
        return $this->post;
    }

    public function setPost(array $post)
    {
        $this->post = $post;
    }

    public function getGet()
    {
        return $this->get;
    }

    public function setGet(array $get)
    {
        $this->get = $get;
    }

    public function getRequestType()
    {
        return $this->requestType;
    }

    public function setRequestType($requestType)
    {
        $this->requestType = $requestType;
    }

    public function setSession(Session $session)
    {
        $this->session = $session;
    }

    public function getSession()
    {
        return $this->session;
    }

    public function getRoutePart()
    {
        $routeName = explode(\Config\App\URL_PATH, $this->getUri());

        if (count($routeName) > 1)
            $routeName = $routeName[1];
        else
            $routeName = "";

        return $routeName;
    }
}
