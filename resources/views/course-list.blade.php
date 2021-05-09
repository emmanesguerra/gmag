@extends('layouts.dashboard')

@section('title')
<title>GOLDEN MAG - Courses</title>
@endsection

@section('pagetitle')
<i class="fa fa-star"></i>  COURSES
@endsection

@section('module-content')

<div class="row p-3">
    <div class='col-12 contentheader100'>
        COURSES
    </div>
    <div class='col-12 card-content' style='position: relative'>
        @include('common.serverresponse')

        <div class="row p-5">
            @foreach ($courses as $course)
            <div class="card mr-5 mb-5" style="width: 35rem;">
                @if ($course->source == 1)
                <img src="https://img.youtube.com/vi/{{ $course->link_id }}/maxresdefault.jpg" class="card-img-top" alt="...">
                @else 
                    @if(!empty($course->file_thumbnail))
                    <img src="{{ asset('storage/courses/thumb/'. $course->file_thumbnail) }}" class="card-img-top" alt="..." width="auto" height="196">
                    @else
                    <img src="{{ asset('images/blackvideo.jpg') }}" class="card-img-top" alt="..." height="196">
                    @endif
                @endif
                <div class="card-body d-flex" style=' flex-direction: column;'>
                    <h4 class="card-title">{{ $course->title }}</h4>
                    <p id='course-desc-{{$course->id}}' class="card-text" style='flex: 1;line-height: 22px;'>{{ $course->description }}</p>
                    @if ($course->source == 1)
                    <a href="{{ $course->link }}" target="_blank" class="btn btn-primary">Visit Link</a>
                    @else 
                    <button type="button" class='btn btn-primary' onclick='watch(this, "{{ $course->title }}", "course-desc-{{$course->id}}")' data-filepath="{{ asset('storage/courses/' . $course->filename) }}">
                        Watch Course
                    </button>
                    @endif
                </div>
            </div>
            @endforeach 
        </div>
        
        {{ $courses->withQueryString()->links() }}
    </div>
</div>

<div class="modal fade" id="watchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div id='modal-dialog' class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id='modal-title' class="modal-title">Watch Course</h5>
            </div>
            <div class="modal-body">
                <div id="theater">
                    <video id="video" controls="false" width="100%" style='display: none'></video>
                    <canvas style='display: flex' id="canvas" width="100%"></canvas>
                </div>
                <p id='modal-description' class=' pt-4' style='line-height: 22px;'>
                    
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
@endsection

@section('javascripts')    
    <script>
        
        function watch(el, title, targetdesc) {
            var filepath = $(el).data('filepath');
            $('#video').attr('src', filepath); 
            $('#modal-title').html(title);
            $('#watchModal').modal('show');
            var desc = $('#'+targetdesc).html();
            $('#modal-description').html(desc);
        }
            
        var canvas = document.getElementById('canvas');
        var ctx = canvas.getContext('2d');
        var video = document.getElementById('video');

        video.addEventListener('loadedmetadata', function() {
            canvas.width =  video.videoWidth;
            canvas.height = video.videoHeight;
            
            $('#modal-dialog').css('width', video.videoWidth + 30);
            $('#modal-dialog').css('max-width', video.videoWidth + 30);
        });

        video.autoplay = true;
        video.load();

        video.addEventListener('play', function() {
            var $this = this; //cache
                (function loop() {
                    if (!$this.paused && !$this.ended) {
                        ctx.drawImage($this, 0, 0);
                        setTimeout(loop, 1000 / 30); // drawing at 30fps
                    }
            })();
        }, 0);  
    </script>
@endsection