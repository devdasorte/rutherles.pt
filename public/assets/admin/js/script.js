function getCookie(name) {
    const cookieArr = document.cookie.split('; ');
    for (const cookie of cookieArr) {
        const [key, value] = cookie.split('=');
        if (name === key.trim()) {
            return decodeURIComponent(value);
        }
    }
    return null;
}

function getQueryParam(param) {
    const params = new URLSearchParams(window.location.search);
    return params.get(param);
}

$(document).ready(function() {
    const action = getQueryParam('action');
    const page = getQueryParam('page');

    if (action === 'logout') {
        $('#sair').trigger('click');
        handleLogout();
    }

    if (page) {
        checkSession();
    }

    function handleLogout() {
        const token = getCookie('XSRF-TOKEN');
        console.log(token);

        fetch(_base_domain_ + 'logout', {
            method: 'POST',
            credentials: 'include',
            headers: {
                'X-XSRF-TOKEN': token,
                'Accept': 'application/json, text/plain, */*',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(resp => {
            console.log(resp);
            if (resp.status === 'success') {
                location.href = '/rifa/admin/login.php';
            } else {
                console.error('Logout failed:', resp);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function checkSession() {
        // Ensure the CSRF token is set
        fetch(_base_domain_ + "sanctum/csrf-cookie", { method: 'GET' })
        .then(() => {
            const token = getCookie('XSRF-TOKEN');
            if (token) {
                $.ajax({
                    url: _base_domain_ + "check",
                    method: 'POST',
                    headers: {
                        'X-XSRF-TOKEN': token,
                        'Accept': 'application/json, text/plain, */*',
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    dataType: 'json',
                    success: function(resp) {
                        if (resp.status == 'success') {
                            location.href = '/rifa/admin';
                        }
                    },
                    error: function(err) {
                        console.error('Session check failed:', err);
                        location.href = _base_url_ + 'class/Auth.php/?action=logout';
                    }
                });
            } else {
                location.href = _base_url_ + 'class/Auth.php/?action=logout';
            }
        })
        .catch(error => {
            console.error('Error setting CSRF token:', error);
            location.href = _base_url_ + 'class/Auth.php/?action=logout';
        });
    }
});
