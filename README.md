# PolidogReduxReactSsrBundle

PolidogReduxReactSsrBundle is a [Koriym.ReduxReactSsr](https://github.com/koriym/Koriym.ReduxReactSsr) support Bundle for Symfony2 or 3

## Prerequisites
- php7
- V8Js
- Symfony2 or Symfony3

## Install

install polidog/redux-react-ssr-bundle with composer.

```
$ composer require polidog/redux-react-ssr-bundle "@dev"
```

## Configuration

```
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Polidog\ReactJsBundle\PolidogReactJsBundle(),
        // ...
    );
}
```

Configure the paths to your react.js and components javascript files and default twig template:

```
# app/config.yml

polidog_react_js:
    react_lib_src: "%kernel.root_dir%/../web/js/react.bundle.js"
    react_app_src: "%kernel.root_dir%/../web/js/app.bundle.js"
    default_template: "::ssr.html.twig"
```

## Usage

controller:

```
<?php
...
    /**
     * @Route("/", name="ssr")
     * @SsrTemplate()
     *
     * @param Request $request
     * @return array
     */
    public function indexAction(Request  $request)
    {
        $state = ['hello'=> ['message' => 'Hello SSR !']];
        return [
            'state' => $state,
        ];
    }


```

twig:

```
<!DOCTYPE html>
<html>
<head>
    <title>Hello CSR</title>
</head>
<body>
<div id="root">{{ markup|raw }}</div>
<script src="{{ asset('client/react.bundle.js') }}"></script>
<script src="{{ asset('client/app.bundle.js') }}"></script>
<script>
{{ js|raw }}
</script>
</body>
</html>
```

### react-router

controller:

```
<?php
...
    /**
     * @Route("/", name="ssr")
     * @SsrTemplate(router=true)
     *
     * @param Request $request
     * @return array
     */
    public function indexAction(Request  $request)
    {
        $state = ['hello'=> ['message' => 'Hello SSR !']];
        return [
            'state' => $state,
        ];
    }

```


## Todo

- test case
