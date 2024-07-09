<section class="bg-white my-3 py-4 px-3 rounded-lg drop-shadow-md shadow-lg">
  <table class="w-full">
    <thead>
      <tr class="bg-slate-200">
        <th class="py-3">Number</th>
        <th class="py-3">Title</th>
        <th class="py-3">Labels</th>
        <th class="py-3">Assignees</th>
        <th class="py-3">Date Created</th>
        <th class="py-3">Data Updated</th>
      </tr>
    </thead>
    <tbody id="issueTbody"></tbody>
  </table>
</section>

<script type="text/javascript">
$(document).ready(function() {
  const Headers = {
    "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content"),
  };

  $("#selectRepo").val("");

  getIssues("issues");

  function getIssues(githubService, repoName) {
    try {
      const issueURL = "https://api.github.com/user/issues";
      const repoIssuesURL = "https://api.github.com/repos/" + "{!! Auth::User()->nickname !!}" + "/" + repoName + "/issues";
      // const viewIssueURL = githubService === "repos" ? issue?.repository?.name : issue?.repository?.name

      $.ajaxSetup({
        Headers,
      });
      $.ajax({
        beforeSend: function (xhr) {
          xhr.setRequestHeader("Authorization", "Bearer " + "{!! Auth::User()->github_token !!}");
        },
        url: githubService === "repos" ? repoIssuesURL : issueURL,
        type: "GET",
        dataType: "json",
        success: (response) => {
          const issuesBody = $("#issueTbody");
          issuesBody.empty();
          let issueData = "";
          if (response.length > 0) {
            $.each(response, (i, issue) => {
              issueData += `
                <tr class="border-b border-gray-300">
                  <td class="flex justify-center items-start py-3"><a href="/repos/`+ (githubService === "repos" ? repoName : issue.repository.name) +`/issues/`+issue.number+`" class="text-blue-700 underline flex" title="See datails">`+issue.number+`
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25" />
                    </svg>
                  </a>
                  </td>  
                  <td class="text-center max-w-72">`+issue.title+`</td>  
                  <td class="text-center">
              `;
              $.each(issue.labels, (l, il) => {
                issueData += `
                  <span class="bg-[#`+il.color+`] w-3 h-3 rounded-full inline-block" title="`+il.name+`"></span>
                `;
              });
              issueData += `
                  </td>  
                  <td class="text-center max-w-44">
              `;
                $.each(issue.assignees, (a, ia) => {
                  issueData += `
                  <span class="flex justify-center">
                    <img src="`+ia.avatar_url+`" alt="`+ia.login+`" class="w-6 h-6 object-cover rounded-full mr-1">`+ia.login+`
                  </span>
                `;
                });
              issueData += `
                  </td>  
                  <td class="text-center">`+moment(issue.created_at).format("MMMM D, YYYY")+`</td>  
                  <td class="text-center">`+moment(issue.updated_at).format("MMMM D, YYYY")+`</td>  
                </tr>
              `;
            });
          } else {
            issueData += `
              <tr>
                <td colspan="7" class="text-center py-3">No issue has been assigned to you`+ (githubService === "repos" ? " in this repository" : "") +`.</td>  
              </tr>`;
          }

          issuesBody.append(issueData);
        }
      });
    } catch (error) {
      console.log(error);
    }
  }

  $("#selectRepo").on("change", function() {
    if($(this).val() === "") {
      getIssues("issues");
    } else {
      getIssues("repos", $(this).val());
    }
  });
});

</script>