<h3>New contact message</h3>
<p><strong>Name:</strong> {{ $data['name'] }}</p>
<p><strong>Email:</strong> {{ $data['email'] }}</p>
<p><strong>Phone:</strong> {{ $data['phone'] ?? '-' }}</p>
<p><strong>Message:</strong></p>
<p>{!! nl2br(e($data['message'])) !!}</p>
