@section("title", "Issue #".$issueNumber." ".$repo." |")

<x-app>
  <section id="issueSection" class="bg-white my-3 py-8 px-3 rounded-lg drop-shadow-md shadow-lg flex justify-center relative"></section>
</x-app>

<script type="text/javascript">
$(document).ready(function(){
  const Headers = {
    "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
  };

  getIssueDetails();
  
  function getIssueDetails () {
    try {
      const issueByRepoURL = "https://api.github.com/repos/{!! Auth::User()->nickname !!}/{!! $repo !!}/issues/{!! $issueNumber !!}";
      const orgName = "{!! $org !!}";
      const issueByOrgURL = "https://api.github.com/repos/" + orgName + "/{!! $repo !!}/issues/{!! $issueNumber !!}"

      $.ajaxSetup({
        Headers,
      });
      $.ajax({
        beforeSend: function (xhr) {
          xhr.setRequestHeader("Authorization", "Bearer " + "{!! Auth::User()->github_token !!}");
        },
        url: orgName !== "n" ? issueByOrgURL : issueByRepoURL,
        type: "GET",
        dataType: "json",
        success: (response) => {
          const issueSection = $("#issueSection");
          issueSection.empty();
          let issueDetails = "";
          issueDetails +=`
            <div class="absolute top-5 left-10">
              <a href="/">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75 3 12m0 0 3.75-3.75M3 12h18" />
                </svg>  
              </a>
            </div>
            <div class="w-[65%]">
              <h1 class="text-2xl text-sky-600">
                `+response.title+` #`+response.number+`
              </h1>
              <div class="my-5 py-5 px-3 bg-slate-100 rounded-md">
                `+response.body+`
              </div>
              <div>
                `;
                  $.each(response.labels, (i, label) => {
                    issueDetails += `
                      <span class="bg-[#`+label.color+`] rounded-full px-2 border border-black text-black m-2" title="`+label.name+`">`+label.name+`</span>
                    `;
                  });
              issueDetails +=`
              </div>
              <div class="mb-5 mt-10 text-gray-800 flex">
                <span class="text-gray-400 mr-2">Assigned to</span>
                `;
                $.each(response.assignees, (i, asn) => {
                  issueDetails += `
                    <span class="flex inline-block"><img src="`+asn.avatar_url+`" alt="`+asn.login+`" class="w-6 h-6 object-cover rounded-full">`+asn.login+`</span>
                  `;
                });
              issueDetails +=` 
              </div>
              <div class="text-gray-800">
                <span class="text-gray-400">Date created</span>
                `+moment(response.created_at).format("MMMM D, YYYY")+`  
              </div>
              <div class="text-gray-800">
                <span class="text-gray-400">Date updated</span>
                `+moment(response.updated_at).format("MMMM D, YYYY")+`  
              </div>
            </div>
          `;

          issueSection.append(issueDetails);
        }
      });
    } catch (error) {
      console.log(error);
    }
  }
});
</script>