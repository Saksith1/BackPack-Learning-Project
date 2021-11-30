{{-- image column type --}}
@php
  $value = data_get($entry, $column['name']);
  
  if($value) {
    $column['height'] = $column['height'] ?? "25px";
    $column['width'] = $column['width'] ?? "auto";
    $column['radius'] = $column['radius'] ?? "3px";
    $column['prefix'] = $column['prefix'] ?? '';

    if (is_array($value)) {
      $value = json_encode($value);
    }

    if (preg_match('/^data\:image\//', $value)) { // base64_image
      $href = $src = $value;
    } elseif (isset($column['disk'])) { // image from a different disk (like s3 bucket)
      $href = $src = Storage::disk($column['disk'])->url($column['prefix'].$value);
    } else { // plain-old image, from a local disk
      $href = $src = asset( $column['prefix'] . $value);
    }

    $column['wrapper']['element'] = $column['wrapper']['element'] ?? 'a';
    $column['wrapper']['href'] = $column['wrapper']['href'] ?? $href;
    $column['wrapper']['target'] = $column['wrapper']['target'] ?? '_blank';
    $column['wrapper']['data-lightbox'] = 'example-2';
    $column['wrapper']['data-title'] = 'Optional caption.';
    
  }
@endphp

<span>
  @if( empty($value) )
    -
  @else
    @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_start')
        <img class="btn_pupup_image" src="{{ $src }}" style="
        max-height: {{ $column['height'] }};
        width: {{ $column['width'] }};
        border-radius: {{ $column['radius'] }};"
        alt="{{ $src }}"/>
    @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_end')
  @endif
</span>
