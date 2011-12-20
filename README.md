# IngewikkeldWrapperBundle

## What is it?

IngewikkeldWrapperBundle is a simple Symfony2 bundle to wrap your old legacy symfony 1 application. This allows you to gradually refactor your old symfony 1 code with spankin' new Symfony2 code.

IngewikkeldWrapperBundle works with a fallback route. All routes that are not caught by your Symfony2 code are routed into the IngewikkeldWrapperBundle, which in turn bootstraps your symfony 1 project.

**Note**: While this bundle can be very useful, it is not recommended to use it for too long. You *are* running two different frameworks for each request that goes through this bundle, meaning there's two frameworks adding an overhead to each request. If you have the possibility, look into caching the output of your legacy code in Symfony2.

## Installation

Installation is done in just a couple of steps:

1. Download the bundle
2. Configure the autoloader
3. Enable the bundle
4. Configure your legacy project
5. Copy your assets to the document root
6. Configure your routing
7. Refactor your project

### 1. Download the bundle

Make sure the bundle is being placed in vendor/bundles/Ingewikkeld/IngewikkeldWrapperBundle. You can do this by using the vendors script, using submodules or downloading the zip file.

#### vendors script
Open the *deps* file in your Symfony2 project, and add the following:

    [IngewikkeldWrapperBundle]
   	    git=git://github.com/Ingewikkeld/IngewikkeldWrapperBundle.git
    	target=bundles/Ingewikkeld/WrapperBundle

Now, install the vendors by running:

	$ bin/vendors install

#### submodules
If you are using Git, you can also use submodules to install the bundle into your project. Execute the following commands in your project root:

    $ git submodule add git://github.com/Ingewikkeld/IngewikkeldWrapperBundle.git vendor/bundles/Ingewikkeld/WrapperBundle
    $ git submodule update --init

#### zip file
Of course, you can just download the zip file from [Github](https://github.com/Ingewikkeld/IngewikkeldWrapperBundle). Unzip the file and copy the contents of the zip-file into the *vendor/bundles/Ingewikkeld/WrapperBundle* directory of your Symfony2 project.

### 2. Configure the autoloader

Before the Ingewikkeld namespace can be loaded, we need to set up the autoloader to actually load the namespace. For this to work, you need to edit the *app/autoload.php* file. In the $loader->registerNamespaces() call, you need to add the Ingewikkeld namespace, like this:

    $loader->registerNamespaces(array(
		// ...
        'Ingewikkeld'      => __DIR__.'/../vendor/bundles',
    ));

### 3. Enable the bundle

Enable the bundle in the AppKernel (*app/AppKernel.php*). In the registerBundles() method, add the WrapperBundle to the $bundles array:

       $bundles = array(
			// ...
            new Ingewikkeld\WrapperBundle\IngewikkeldWrapperBundle(),
        );
### 4. Configure your legacy project

Put your legacy project in your *app/* directory. For my first project, I put my whole project into the *app/legacy/* directory. Now, add some configuration values to *app/config/config.yml* to set up the WrapperBundle to serve pages from your legacy symfony 1 project:

    parameters:
        wrapper_legacypath: legacy # directory inside app/ where your project is located
        wrapper_app: frontend # app to load
        wrapper_env: prod #environment to load
        wrapper_debug: false #whether debug is on or not

### 5. Copy your assets to the document root

All files that need to be available in the document root need to be copied there from your legacy project. Right now, those are not yet automatically loaded (see "Known issues"), so they have to be copied over to the *web/* directory of your Symfony2 project. Usually, you copy over the images/, css/, js/ and uploads/ directories.

### 6. Configure your routing

At the bottom of your *app/config/routing.yml* file, add the following:

IngewikkeldWrapperBundle:
    resource: "@IngewikkeldWrapperBundle/Controller/"
    type:     annotation
    prefix:   /

This will ensure the wrapper route will catch all requests that are not caught by any other route.

### 7. Refactor your project

Now, start refactoring and porting your legacy project into Symfony2 code. 

## Current state of the project

The current state of the project is: **Proof of Concept**

It is working for me right now for one of my legacy projects using this approach. This is with a symfony 1.0 project. It might not (yet) work for you. I greatly welcome pull requests to add features or ensure compatibility with other versions of symfony 1. If you've confirmed this bundle to work with another version of symfony 1, please also let me know!

## Known issues / TODO

1. Assets are not automatically loaded but have to be copied over to the Symfony2 documentroot
2. Compatibility is so far only confirmed with symfony 1.0
3. It is currently only possible to load one symfony 1-app
