@extends('layouts.main')

@section('page')
<main id="login">
  <section>
    <div class="wrap">
      <h1 class="sct-title">Login</h1>

      <form class="login-wrap">
        <input type="text" v-model="email" placeholder="E-mail">
        <input type="password" v-model="password" placeholder="Password">

        <button class="btn" @click.prevent="login">Login</button>
      </form>
    </div>
  </section>
</main>
@stop

@push('styles')
<style>
  .login-wrap {
    width: 320px;
    margin: 64px auto 0;
  }

  .login-wrap input {
    width: 100%;
    display: block;
  }

  .login-wrap button {
    width: 100%;
    margin-top: 32px;
  }
</style>
@endpush

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