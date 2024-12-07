@extends('layout')
@section('title','Contact Us')


@section('style')
<link rel="stylesheet" href="{{ asset('/css/contact.css') }}"/>
@endsection

@section('content')
<div class="container hero-content">
    <div class="text-center">
        <h1 class="mb-1 mt-5 fw-bold">CONTACT</h1>
    </div>
    
    <div class="mt-5 ">
        <div class="text_deg ">
           
            <div class="row">
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <p>
                        Call/Whatsapp
                        <br>
                        081231231234 (Jakarta)
                        <br>
                        081231231234 (Bandung)
                    </p>
                    <p>
                        Call: 02143212345
                        <br>
                        Line ID : @bloomnigflorist
                    </p>
                </div>
            </div>
        </div>
            <div class="row">
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="contact-form mb-5">
                        @if(Session::has('message'))
                            <p class="alert alert-success">{{ Session::get('message') }}</p>
                        @endif
                        <form method="POST" name="emailContact" action="/post_message">
                            @csrf
                            <div class="mb-3">
                              <input type="text" class="form-control" name="name" id="name"  placeholder="Your Name" required>
                            </div>
                            <div class="mb-3">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
                              </div>
                              <div class="mb-3">
                               <textarea class="form-control" name="message" id="message"  placeholder="Your Message" cols="30" rows="10" required></textarea> 
                              </div>
                         
                            <button type="submit" class="btn btn-primary">Submit</button>
                          </form>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="map-area">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.4685425913895!2d106.7796797750102!3d-6.201753160753414!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f6dcc7d2c4ad%3A0x209cb1eef39be168!2sBINUS%20University%2C%20Kampus%20BINUS%20Anggrek!5e0!3m2!1sen!2sid!4v1715011057807!5m2!1sen!2sid" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
            </div>

            </div>
        
    </div>

</div>

@endsection

