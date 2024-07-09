<x-app>
  <section>
    {{-- <div>
      <h1>Hello {{ Auth::User()->name }}!</h1>
    </div> --}}
    <div class="flex mt-5">
      <x-select selectNoValue="Select repository" :arrToMap="$repos" opts="name" selId="selectRepo" />
      {{-- <x-select :arrToMap="$orgs" selectNoValue="Select organization" opts="login" /> --}}
    </div>
    <x-issue-table :userAccessToken="$userAccessToken" />
  </section>
</x-app>
