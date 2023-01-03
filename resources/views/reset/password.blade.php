<html>
    <head>
        @vite('resources/css/app.css')

    </head>
    <body class="w-full h-full flex flex-col justify-center items-center">
        <section class=" w-min px-5 flex flex-col items-center py-5 rounded-xl shadow-xl">
            <div class="mb-5">
                <span class="uppercase text-6xl font-extrabold text-green-800">Kava</span> 
            </div>
            <h1 class="text-3xl  mb-4">Reset account password</h1>
            <div class=" text-center rounded-md  text-lg p-3   -shadow-md mb-4">
                <span class="text-red-500">All passwords are persisted using secure and advanced <i>one-way functions</i> conforming to 
                    <strong>RFC</strong> standards. Not even the  admins of KAVA can see your password.
                </span>
            </div>
            <form  method="post" action="{{url('/reset-password')}}" class=" w-[500px]   flex flex-col">
                @csrf
                <input class="border  mb-4 h-10 rounded-sm outline-none px-4" type="email" name="email"  placeholder="Enter your email address" />
                @error('email')
                    <span class="mb-2 text-red-500">
                        {{$errors->first('email')}}
                    </span>
                @enderror
                <input class="border  mb-4 h-10 rounded-sm outline-none px-4" type="password" name="password"  placeholder="Enter new password" />
                @error('password')
                    <span class="mb-2 text-red-500">
                        {{$errors->first('password')}}
                    </span>
                @enderror
                <input class="border  mb-1 h-10 rounded-sm outline-none px-4" type="password" name="password_confirmation"  placeholder="Confirm password" />
                @error('password_confirmation')
                <span class="mb-2 text-red-500">
                    {{$errors->first('password_confirmation')}}
                </span>
            @enderror
                <input type="hidden"  name="token" value="{{$token}}" />
                <div class="flex justify-center mt-3">
                    <button type="submit" class="border  w-full  py-1  rounded-lg bg-green-800 text-white text-lg">Reset Password</button>
                </div>
            </form>
        </section>

    </body>
</html>
