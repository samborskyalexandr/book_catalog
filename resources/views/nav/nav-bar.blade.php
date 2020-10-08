<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="/">
            <img class="logo" src="{{asset('/img/logo.svg')}}" alt="Books">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item <?= Request::path() == 'books' ? 'active' : '' ?>">
                    <a class="nav-link" href="/books">Books</a>
                </li>
                <li class="nav-item <?= Request::path() == 'authors' ? 'active' : '' ?>">
                    <a class="nav-link" href="/authors">Authors</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
