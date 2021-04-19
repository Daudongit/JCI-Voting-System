<meta property="og:title" content="{{config('app.og_title')}}" />
<meta property="og:description" content="{{config('app.og_description')}}" />
<meta property="og:image" content="{{asset(config('app.og_image'))}}" />
<meta property="og:url" content="{{request()->fullUrl()}}">
<meta name="twitter:card" content="{{asset(config('app.og_image'))}}">


<!--  Non-Essential, But Recommended -->

<meta property="og:site_name" content="{{config('app.og_title')}}">
<meta property="og:type" content="website" />
<meta name="twitter:image:alt" content="{{asset(config('app.og_image'))}}">