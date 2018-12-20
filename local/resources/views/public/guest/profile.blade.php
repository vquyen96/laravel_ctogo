@extends('public.grand-master')

@section('css')
<link rel="stylesheet" type="text/css" href="guest/css/yourhomestay.css">
<link rel="stylesheet" type="text/css" href="guest/css/profile.css">
@stop

@section('javascript')
<script type="text/javascript" src="guest/js/profile.js"></script>
<script type="text/javascript">
		$(document).ready(function(){
			$('.ava').click(function(){
				$('#ava-input').click();
			});

			$('#ava-input').change(function(e){
	            $('#ava-form').submit();
	        });

	        $('#ava-form').on('submit',function(e){
	        	e.preventDefault();
	        	$.ajax({
					url: "{{ asset('user/ajaxAvatar') }}",
					type: "POST",
					data: new FormData(this),
					contentType: false,
					cache: false,
					processData:false
				}).done(function(e){
				    console.log(e);
					$('.ava').attr('style','background-image:url( {{ asset('local/storage/app/image/user-3/') }}/'+ e.avatar +' )');
					$('.avatar').attr('style','background-image:url( {{ asset('local/storage/app/image/user-3/') }}/'+ e.avatar +' )');
				});
	        });


            $('.image_payment').click(function(){
                $('#file_image_payment').attr('book_id',$(this).attr('book_id'));
                $('#file_image_payment').click();
            });

            $('#file_image_payment').change(function(e){
                e.preventDefault();
                var file_data = $('#file_image_payment').prop('files')[0];
                var book_id = $('#file_image_payment').attr('book_id');
                var type = file_data.type;
                var match= ["image/gif","image/png","image/jpg","image/jpeg"];
                if(type == match[0] || type == match[1] || type == match[2] || type == match[3])
                {
                    var form_data = new FormData();
                    form_data.append('image_payment', file_data);
                    form_data.append('book_id', book_id);
                    $.ajax({
                        url: '{{route('upload_image_payment')}}',
                        dataType: 'text',
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,
                        type: 'post',
                        success:function (result) {
                            var data = JSON.parse(result);
                            if(data.status == 1){
                                $("#snackbar").html("Upload thành công");
                                $("#snackbar").addClass('success_mes');
                                $("#snackbar").addClass('show');
                                // After 3 seconds, remove the show class from DIV
                                setTimeout(function () {
                                    $("#snackbar").removeClass('show');
                                }, 3000);
                            }else {
                                $("#snackbar").html("Upload không thành công");
                                $("#snackbar").addClass('error_mes');
                                $("#snackbar").addClass('show');
                                // After 3 seconds, remove the show class from DIV
                                setTimeout(function () {
                                    $("#snackbar").removeClass('show');
                                }, 3000);
							}
                        }
                    });
                } else{
                    $("#snackbar").html("File không đúng định dạng");
                    $("#snackbar").addClass('error_mes');
                    $("#snackbar").addClass('show');
                    // After 3 seconds, remove the show class from DIV
                    setTimeout(function () {
                        $("#snackbar").removeClass('show');
                    }, 3000);
                }
                return false;
            });


		// keep tab on reload
		$('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
			localStorage.setItem('activeTab', $(e.target).attr('href'));
		});
		var activeTab = localStorage.getItem('activeTab');
		if(activeTab){
			$('#myTab a[href="' + activeTab + '"]').tab('show');
		}

	});

</script>

@stop

@section('main')
<section class="hs-section">
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-4 col-lg-4">
				<div id="sidebar">
					<div class="ava" style="background-image: url({{ (file_exists(storage_path('app/image/user-3/'.Auth::user()->avatar)) && Auth::user()->avatar != '') ? asset('local/storage/app/image/user-3/'.Auth::user()->avatar) : Auth::user()->avatar }});">
						<img src="{{ asset('local/storage/app/image/ava-subtitute.png') }}">
					</div>

					<form style="display: none;" id="ava-form" enctype="multipart/form-data" method="post">
						{{csrf_field()}}
						<input id="ava-input" style="display: none;" type="file" name="image">
					</form>

					<div class="info">
						<p class="white fs-24 semibold center mb-1">{{ Auth::user()->name ?? '' }}</p>
						<p class="white fs-14 center">{{ Auth::user()->email ?? '' }}</p>
					</div>

					<ul class="nav nav-tabs" id="myTab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="account-tab" data-toggle="tab" href="#account" role="tab" aria-controls="account"><i class="fas fa-user"></i> Tài khoản của bạn</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="password-tab" data-toggle="tab" href="#password" role="tab" aria-controls="password"><i class="fas fa-key"></i> Thay đổi mật khẩu</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="manage-tab" data-toggle="tab" href="#manage" role="tab" aria-controls="manage"><i class="fas fa-cog"></i> Quản lý đặt phòng</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="noti-tab" data-toggle="tab" href="#noti" role="tab" aria-controls="noti"><i class="fas fa-bell"></i> Thông báo <span class="has-noti">{{$count_notification}}</span></a>
						</li>
					</ul>

					<a href="{{ asset('user/logout') }}" class="signout">Đăng xuất <i class="fas fa-sign-out-alt"></i></a>
				</div>
			</div>

			<div class="col-12 col-md-8 col-lg-8">
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active ml-5" id="account" role="tabpanel" aria-labelledby="account-tab">
						<h2 class="bold fs-24 black">Tài khoản của bạn</h2>

						<form id="form-account" method="post" action="{{ asset('user/updateProfile') }}">
							<div class="form-item-2">
								<label>Họ và tên <span title="Thông tin bắt buộc">*</span></label>
								<input type="text" name="name" placeholder="Họ và tên" value="{{ Auth::user()->name ?? ''}}">
							</div>

							<div class="form-item-2">
								<label>Số điện thoại</label>
								<input type="text" name="phone" placeholder="Số điện thoại" value="{{ Auth::user()->phone ?? "" }}">
							</div>

							<div class="form-item-2">
								<label>Giới tính</label>
								<select name="sex">
									<option @if ( isset(Auth::user()->sex) && Auth::user()->sex == 1 ) selected="" @endif value="1">Nam</option>
									<option @if ( isset(Auth::user()->sex) && Auth::user()->sex == 2 ) selected="" @endif value="2">Nữ</option>
								</select>
							</div>

							<div class="form-item-2">
								<label>Giới thiệu:</label>
								<textarea name="description" placeholder="Giới thiệu về bạn">{{Auth::user()->description ?? ''}}</textarea>
								<div class="tip-text">Tối đa 100 ký tự</div>
							</div>

							<div class="form-item-2 form-item-2-btn">
								<button class="save-btn" type="submit">Lưu</button>
							</div>

							{{ csrf_field() }}
						</form>
					</div>

					<div class="tab-pane fade ml-5" id="password" role="tabpanel" aria-labelledby="password-tab">
						<h2 class="bold fs-24 black">Đổi mật khẩu</h2>
						@if (session('error'))
						<div class="alert alert-danger">
							{{ session('error') }}
						</div>
						@endif
						@if (session('success'))
						<div class="alert alert-success">
							{{ session('success') }}
						</div>
						@endif
						<form id="form-changepassword" method="post" action="{{ asset('user/updatePassword') }}">
							<div class="form-item-2">
								<label>Mật khẩu cũ:</label>
								<input type="password" name="old_password" placeholder="Mật khẩu cũ" value="">
							</div>

							<div class="form-item-2">
								<label>Mật khẩu mới:</label>
								<input type="password" id="password" name="new_password" placeholder="Mật khẩu mới" value="">
							</div>

							<div class="form-item-2">
								<label>Nhập lại mật khẩu mới:</label>
								<input type="password" name="confirm_password" placeholder="Xác nhận mật khẩu" value="">
							</div>

							<div class="form-item-2">
								<button class="save-btn" type="submit">Lưu</button>
							</div>

							{{ csrf_field() }}
						</form>
					</div>

					<div class="tab-pane fade" id="manage" role="tabpanel" aria-labelledby="manage-tab">
						<h2 class="bold fs-24 black">Quản lý đặt phòng</h2>

						<div id="book-table">
							<table>
								<thead>
									<tr>
										<td style="width: 110px;">Mã đặt phòng</td>
										<td>Homestay</td>
										<td>Thời gian</td>
										<td>Chờ thanh toán</td>
										<td>Chi phí</td>
										<td>Tình trạng</td>
										<td style="min-width: 120px">Thao tác</td>
									</tr>
								</thead>

								<tbody>
								@foreach($list_book as $book)
									<tr>
										<td>{{$book->code}}</td>
										@if($book->homestay)
											<td>{{ $book->homestay->homestay_name }}</td>
										@else
											<td>Homestay đã dừng hoạt động</td>
										@endif
										<td>{{$book->book_from}} -- {{$book->book_to}}</td>
										@if($book->book_status != 3)
											<td>{{$book->del_time['h']}}:{{$book->del_time['m']}}:{{$book->del_time['s']}}</td>
										@else
											<td>0</td>
										@endif

										<td>{{number_format($book->price)}} vnd</td>
										<td><span class="text-warning" title="{{getStatusBookStr($book->book_status)['title']}}">{{getStatusBookStr($book->book_status)['str']}}</span></td>
										<td class="float-right action-order" style="border: 0px;margin-right: 12px">
											@if($book->time_del >= time())
												<a book_id="{{$book->book_id}}" class="image_payment" style="cursor: pointer" title="{{(file_exists(storage_path('app/image/image-payment/'.$book->image_payment)) && $book->image_payment != null) ? "Đã upload ảnh ủy nhiệm chi" : "Upload ảnh ủy nhiệm chi"}}"><i class="fa fa-image text-danger"></i></a>
											@endif
											<a class="{{$book->book_status != 1 ? 'd-none' : ''}}" href="{{route('ck_confirm',$book->book_id)}}" title="Thanh toán"><i class="fa fa-shopping-cart text-info"></i></a>
											<a onclick="return seeDetailModal({{$book->book_id}});" title="Chi tiết"><i class="fa fa-eye text-primary"></i></a>
											<a href="{{route('update_status_book',['id' => $book->book_id,'status' => 4])}}" title="Hủy"><i class="fa fa-trash text-danger"></i></a>
										</td>
									</tr>
								@endforeach
								<input type="file" class="d-none" id="file_image_payment" name="image_payment">
								</tbody>
							</table>
							<div class="float-right" style="margin:20px 0">
								{{$list_book->links()}}
							</div>
						</div>
					</div>

					<div class="tab-pane fade ml-5" id="noti" role="tabpanel" aria-labelledby="noti-tab">
						<h2 class="bold fs-24 black">Thông báo</h2>

						<div id="noti-cont">
							<div class="noti-list">
								@foreach($list_notification as $noti)
									<a class="unread">
										<p>
											<b>{{get_actor($noti->type)}}</b>
											<span>:</span> {{$noti->message}}
										</p>
										<p class="fs-12 grey-a"><i
													class="fas fa-clock"></i>{{date('d/m/Y H:m',$noti->created_at)}}</p>
									</a>
								@endforeach
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				{{--ajax see detail modal here--}}
			</div>
		</div>
	</div>
</div>
@stop