<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Chemiatria</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    <a href="{{ url('/login') }}">Login</a>
                    <a href="{{ url('/register') }}">Register</a>
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Chemiatria: Learn Chemistry
                </div>
                <p>Chemiatria is a collection of tools and games to help you learn chemistry quickly and painlessly,
                    informed by current science on how people most quickly master new material. For example,
                    you can use spaced repetition to learn facts quickly, and you can learn to recognize patterns
                    effortlessly (for example, to see if Lewis structures are correct at a glance) by seeing many
                    examples quickly.</p>
                <p>I ask you to sign up before you use the site so it can track your progress and help you
                    efficiently. Chemiatria is completely free, and will always be completely free. There are
                    no purchases available, or premium subscriptions, or any other way to collect your money.</p>
                <p>However, <a href="{{ url('/Lewis') }}">this intro</a> to Lewis structures is available without logging in. Check it out!</p>
                

                <div class="links">
                    <a href="http://www.graylark.com/eve/Chemiatria">Old Version</a>
                    <a href="http://www.graylark.com/eve">My GenChem 1 reference site</a>
                    <a href="https://www.github.com/evames/">My projects on GitHub</a>
                </div>
            </div>
        </div>
    </body>
</html>
