<x-guest-layout>
  <x-auth-card>
<div class="container-fluid">
  <div class="row">

    <main>
      <div class="row">
        <div class="col-12">
          <div class="login-wrapper">
            <form action="login_submit" method="get" accept-charset="utf-8">
                <div class="row">
                <div class="col-12 text-center mb-5">
                  <a class="navbar-brand" href="index.html">
                    <img src="{{asset('alfardan/assets/logo.png')}}">
                  </a>
                </div>
              </div>

              <div class="row">
                <div class="col-12">
                  <input type="email" name="email" placeholder="Email">
                  <input type="text" name="email" placeholder="Password">
                </div>
              </div>

              <div class="row">
                <div class="col-12">
                  <div class="form-group form-check my-1 pb-4 pb-sm-5">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Remember me</label>
                    <a href="#" class="forgot-password">Forgot password?</a>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-12 text-center">
                  <div class="">
                    <a href="#" class="login-btn text-uppercase">Log in</a>
                  </div>
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>
    </main>

  </div>
</div>
</x-auth-card>
</x-guest-layout>
