<h1>Chào bạn, {{ $data['ho_ten'] }}</h1>
<p>Cảm ơn bạn đã đặt câu hỏi: <i>"{{ $data['noi_dung'] }}"</i></p>
<p>Chúng tôi sẽ trả lời bạn trong thời gian sớm nhất!</p>

{{-- Trong mail này ta thấy dùng 2 biến $data['ho_ten'] và $data['noi_dung'] --}}
{{-- Đồng Nghĩa ai mà dùng cái view này thì phải có 2 biến đó --}}
