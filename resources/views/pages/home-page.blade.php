<x-app>
  <section>
    {{-- <div>
      <h1>Hello {{ Auth::User()->name }}!</h1>
    </div> --}}
    <div class="flex mt-5">
      <x-select selectNoValue="Select repository" :arrToMap="$repos" opts="name" selId="selectRepo" className="" />
      <x-select :arrToMap="$orgs" selectNoValue="Select organization" opts="login" selId="selectOrg" className="ml-5" />
    </div>
    <x-issue-table :userAccessToken="$userAccessToken" />
  </section>
</x-app>
