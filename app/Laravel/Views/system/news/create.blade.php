@extends('system._layouts.main')

@section('content')
<div class="main-content container-fluid">
  <div class="row">
    <div class="col-md-8">
      @include('system._components.notifications')
      <div class="panel panel-default panel-border-color panel-border-color-success">
        <div class="panel-heading panel-heading-divider">Create Record Form<span class="panel-subtitle">News information.</span></div>
        <div class="panel-body">
          <form method="POST" action="" enctype="multipart/form-data">
            {!!csrf_field()!!}
            
            <div class="form-group {{$errors->first('title') ? 'has-error' : NULL}}">
              <label>Title</label>
              <input type="text" placeholder="Title of the article" class="form-control" name="title" value="{{old('title')}}">
              @if($errors->first('title'))
              <span class="help-block">{{$errors->first('title')}}</span>
              @endif
            </div>

       {{--      <div class="form-group {{$errors->first('file') ? 'has-error' : NULL}}">
              <label>Thumbnail</label>
              <input type="file"  class="form-control form-file" name="file" value="{{old('file')}}">
              @if($errors->first('file'))
              <span class="help-block">{{$errors->first('file')}}</span>
              @endif
            </div> --}}

            <div class="form-group {{$errors->first('linked_url') ? 'has-error' : NULL}}">
              <label>Embeded Linked URL</label>
              <input type="text" placeholder="URL of the news eg." class="form-control" name="linked_url" value="{{old('linked_url')}}">
              @if($errors->first('linked_url'))
              <span class="help-block">{{$errors->first('linked_url')}}</span>
              @endif
            </div>

           {{--  <div class="form-group {{$errors->first('content') ? 'has-error' : NULL}}">
              <label>Content</label>
              <textarea name="content" id="content" cols="30" rows="10" class="form-control editor">{!!old('content')!!}</textarea>
              @if($errors->first('content'))
              <span class="help-block">{{$errors->first('content')}}</span>
              @endif
            </div> --}}
            
            <div class="row xs-pt-15">
              <div class="col-xs-6">
                  <button type="submit" class="btn btn-space btn-success">Create Record</button>
                  <a href="{{route('system.news.index')}}" class="btn btn-space btn-default">Cancel</a>
              </div>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@stop




@section('page-styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/lib/summernote/summernote.css')}}"/>
@stop

@section('page-scripts')
<script src="{{asset('assets/lib/summernote/summernote.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">
  $(function(){
    $('.editor').summernote({height:300})
  })
</script>
@stop