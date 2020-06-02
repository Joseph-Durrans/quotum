<!DOCTYPE html>
<html lang="en">
<head>
    <title>user panel</title>
</head>
<body>
    <h1>user panel</h1>

    
    <div>
        <a class="dropdown-item" href="{{ route('logout') }}"
           onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">
            {{ __('Logout') }}
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</body>
</html>