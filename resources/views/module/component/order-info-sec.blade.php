@php
    unset($data['desc']);                    
@endphp
@if (!empty($data) && count($data) > 0)
    @foreach ($data as $photoQus)                                    
        @foreach ($photoQus as $ques)
        @if (isset($ques))
            <div class="col-12">
                <label for="" class="form-label">{{ $ques }}</label>
                <textarea
                    type="text"
                    class="form-control qus{{$loop->iteration}}"
                    name="{{ str_replace(' ', '_', $ques) }}"
                    placeholder="Type here"
                    rows="4"
                    cols="50"
                ></textarea>
            </div>
        @endif
        @endforeach
    @endforeach
@endif