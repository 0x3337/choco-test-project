@extends('layouts.main')

@section('page')
  @auth
    The user is authenticated...
  @endauth

  <main id="login">
    <section>
      <div class="wrap">
        <h1>Login</h1>

        <form>
          <input type="text" v-model="email" placeholder="E-mail">
          <input type="password" v-model="password" placeholder="Password">

          <button v-on:click="login">Login</button>
        </form>
      </div>
    </section>
  </main>
@stop

@push('scripts')
  <script>
    (function () {
      var login = new Vue({
        el: '#login',
        data: {
          email: '',
          password: '',
        },
        methods: {
          login: function (event) {
            event.preventDefault();

            l2.ajax({
              url: '/auth/login',
              json: {
                email: this.email,
                password: this.password,
              },
              success: function (res) {
                if (res.success) {
                  location.reload();
                }
              }
            });
          },
        }
      });
    })();
  </script>
@endpush