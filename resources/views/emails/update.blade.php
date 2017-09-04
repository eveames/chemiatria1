<html>
    <body>
        <h3>Hello, {{ $user->name }}</h3>
        <h4>This is your update from Chemiatria.</h4>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <td>stage</td>
                    <td>type</td>
                    <td>detail</td>
                </tr>
            </thead>
            <tbody>
            @foreach($states as $key => $value)
                <tr>
                  <td>{{ $value['stage'] }}</td>
                  <td>{{ $value['type'] }}</td>
                  <td>{{ $value['name'] }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        Key:
        <ul>
          <li>Stage 0-3 indicates material you are still learning</li>
          <li>Stage 4-8 indicates material you know pretty well</li>
          <li>Stage 9-10 indicates material you know really well</li>
        </ul>

    </body>
</html>
