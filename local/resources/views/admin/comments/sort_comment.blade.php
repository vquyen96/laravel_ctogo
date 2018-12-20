@extends('admin.master')

@section('title', 'Sắp xếp bình luận')
@section('main')
	
<div class="content-wrapper">
	<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Sắp xếp bình luận</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ asset('admin') }}">Trang chủ</a></li>
              <li class="breadcrumb-item active">Sắp xếp bình luận</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

	@if (session('error'))
		<div class="alert alert-error">
			<p>{{ session('error') }}</p>
		</div>
	@endif

	@if (session('status'))
		<div class="alert alert-success">
			<p>{{ session('status') }}</p>
		</div>
	@endif

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
			<section class="col-md-12 connectedSortable">
				<!-- TO DO List -->
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">
							<i class="ion ion-clipboard mr-1"></i>
							Bình luận trang chủ
						</h3>
					</div>
					<!-- /.card-header -->
					<form method="post" action="{{route('update_sort_comment')}}">
						{{csrf_field()}}
						<div class="card-body">
							<ul class="todo-list">
								@foreach($list_comment as $comment)
									<li>
										<span class="handle">
										  <i class="fa fa-ellipsis-v"></i>
										  <i class="fa fa-ellipsis-v"></i>
										</span>
										<input style="width: 50px" type="text" value="{{$loop->index + 1}}"
											   name="comment[{{$comment->comment_id}}]">
										<span class="text">{{$comment->comment_content}}</span>
										<span>&nbsp;&nbsp;&nbsp;</span>
										<span>{{$comment->created_at}}</span>
										<div class="tools">
											<a href="{{route('delete_comment_hot',$comment->comment_id)}}" class="text-danger" onclick="return confirm('Bạn chắc chắn muốn xóa')">
												<i class="fa fa-trash-o"></i>
											</a>
										</div>
									</li>
								@endforeach
							</ul>
						</div>
						<!-- /.card-body -->
						<div class="card-footer clearfix" style="margin: 20px 0">
							<button type="submit" class="btn btn-info float-right"><i class="fa fa-plus"></i> Cập nhật
							</button>
						</div>
					</form>
				</div>
			</section>

			<section class="col-md-5 connectedSortable" id="group-child">

			</section>
        </div>
      </div>
    </section>
</div>
@stop
@section('javascript')
	<script>
        // Make the dashboard widgets sortable Using jquery UI
        $('.connectedSortable').sortable({
            placeholder         : 'sort-highlight',
            connectWith         : '.connectedSortable',
            handle              : '.card-header, .nav-tabs',
            forcePlaceholderSize: true,
            zIndex              : 999999
        });
        $('.connectedSortable .card-header, .connectedSortable .nav-tabs-custom').css('cursor', 'move')

        // jQuery UI sortable for the todo list
        $('.todo-list').sortable({
            placeholder         : 'sort-highlight',
            handle              : '.handle',
            forcePlaceholderSize: true,
            zIndex              : 999999,
			update : function () {
				$('.todo-list li').each(function (e) {
					$(this).children('input').val(e + 1);
                })
            }
        })
	</script>
@stop
