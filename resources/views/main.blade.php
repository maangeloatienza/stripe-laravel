<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Stripe Sample Integration</title>

        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="{{ asset('/css/app.css')}}" rel="stylesheet">
        <script src="https://js.stripe.com/v3/"></script>

    </head>
    <body>
        
            
        <div>
            <form action="{{ url('charge') }}" method="post" id="payment-form">
                <div class="form-row">
                    {{ env('STRIPE_PUBLISHABLE_KEY') }}
                    <p><input type="text" name="amount" placeholder="Enter Amount" /></p>
                    <p><input type="email" name="email" placeholder="Enter Email" /></p>
                    <label for="card-element">
                    Credit or debit card
                    </label>
                    <div id="card-element">
                    <!-- A Stripe Element will be inserted here. -->
                    </div>
                
                    <!-- Used to display form errors. -->
                    <div id="card-errors" role="alert"></div>
                </div>
                <button>Submit Payment</button>
                {{ csrf_field() }}
            </form>
            <script>
                
                var publishable_key = 'pk_test_6NSNVAukLVweqoKeyle78A2100xVDwjzQT';
                
            </script>
            <script src="{{ asset('/js/stripe.js') }}"></script>
        
        </div>
    </body>
</html>
