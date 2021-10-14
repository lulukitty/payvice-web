@if($errors->any())

<div class="alert alert-danger">
    <p>
        @if(count($errors->all()) == 1)
            {{$errors->all()[0]}}
        @else

        <ul>
            @foreach($errors->all() as $error)
            <li>{{$error}}</li>
            @endforeach
        </ul>
        @endif
   </p>
    <a class="close" href="#"></a>
</div>

@endif