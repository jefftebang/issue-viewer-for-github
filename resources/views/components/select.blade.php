<section>
  <select name="" id="{{ $selId }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md block w-full p-2.5">
    <option value="">{{ $selectNoValue }}</option>
    @foreach (json_decode($arrToMap) as $key => $arr)
      <option value="{{ $arr->name }}">{{ $arr->$opts }}</option>
    @endforeach
  </select>
</section>