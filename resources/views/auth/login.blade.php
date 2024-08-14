<!DOCTYPE html>
<html>
<style>
body{
    background-color: blue;
}
input[type=email], input[type=password], select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

input[type=submit] {
  width: 100%;
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: #45a049;
}

div {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
  width:20em;
  position: relative;
  margin-top: 20%;
  margin-left:40%;
}
img{
    margin-left: 40em;
    margin-top: -6em;
    position: fixed;
    height: 6em;
    width: 10em;
}
</style>
<body>

<img src="{{asset('logo.jpg')}}"/>

<div >
    @if ($errors->any())

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

    @endif
  <form method="POST" action="{{ route('login') }}">
      @csrf
    <label for="email">Email</label>
    <input type="email" id="email" name="email" placeholder="votre email..." required autofocus autocomplete="email">
    @error('email')
        {{ $message }}

    @enderror

    <label for="password" >Mot de passe</label>
    <input type="password" id="password" name="password" placeholder="votre mot de passe"required autocomplete="current-password">
    @error('password')
            {{ $message }}

    @enderror
  
    <input type="submit" value="Submit">
  </form>
</div>

</body>
</html>