@extends('layout')
@section('title','About Us')


@section('style')
<link rel="stylesheet" href="{{ asset('/css/aboutUs.css') }}"/>
@endsection

@section('content')
<div class="container hero-content">
    <div class="text-center">
        <h1 class="mb-1 mt-5 fw-bold">ABOUT US</h1>
    </div>
    
    <div class="row row-cols-1 row-cols-md-1 row-cols-xl-2 mt-5 ">

        <div class="col img_deg ">
            <img src="https://images.unsplash.com/photo-1554303867-f61340bb2cf5?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="">
        </div>

        <div class="col text_deg ">
            
            <p class="fs-4 mb-3 head">
                Welcome to Blooming, where every petal tells a story and every bouquet blooms with love.
            </p>

            <p>
                At <b>Blooming</b>, we believe in the power of flowers to express emotions, evoke memories, and bring joy to every moment. With a passion for floristry and an eye for detail, we craft exquisite arrangements that speak the language of beauty and elegance.
            </p>

            <p>    
                Our journey began with a simple seed of inspiration – a desire to share the wonder of nature's most delicate creations. From humble beginnings, we have grown into a flourishing oasis of floral artistry, serving our community with dedication and creativity.
            </p>

            <p>
                At the heart of <b>Blooming</b> lies a commitment to quality and innovation. We source the freshest blooms from local growers and hand-select each stem to ensure every arrangement is a masterpiece. Whether you're celebrating a milestone, expressing gratitude, or simply brightening someone's day, our expert florists will work tirelessly to exceed your expectations.
            </p> 

            <p>
                Beyond our stunning arrangements, <b>Blooming</b> is more than just a flower shop – we are storytellers, weaving tales of love, hope, and celebration through the language of flowers. Each bouquet is thoughtfully curated to convey your deepest sentiments, transforming ordinary moments into extraordinary memories.
            </p>

            <p>
            As a trusted member of the community, we take pride in our sustainable practices and eco-friendly approach to floristry. From eco-conscious packaging to responsible sourcing, we are committed to preserving the beauty of our planet for generations to come.
            </p>

            <p>
                Thank you for choosing <b>Blooming</b> to be a part of your special moments. Whether it's a wedding, birthday, or simply a gesture of kindness, let us help you make every occasion blossom with beauty and meaning. Experience the magic of Blooming today and let your love unfurl with every petal.
            </p>
            
        </div>

        
    </div>

</div>

@endsection

