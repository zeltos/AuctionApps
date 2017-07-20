<h1>Hallo! {{ $user_name }}</h1>
<p>Selamat bergabung! Saat ini profil Anda telah terdaftar di Auction brandoutlet.co.id . Silakan aktivasi akun Anda dengan cara klik link di bawah ini:</p>
<p><a href="{{ secure_url('/api/v1/user/activation/').'/'.$activation_key }}">{{ $activation_key }}</a></p>
