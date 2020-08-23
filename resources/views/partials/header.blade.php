<header>
	<nav>
    <a class="nav-logo" href="/">Choco Test Project</a>

		<ul class="nav-list right">
      <li>
        <a class="nl-link" href="/shop">Shop</a>
      </li>

      @guest
        <li>
          <a class="nl-link" href="/login">Login</a>
        </li>
      @endguest
      @auth
        <li>
          <a class="nl-link" href="/logout">Logout</a>
        </li>
      @endauth
		</ul>
	</nav>
</header>