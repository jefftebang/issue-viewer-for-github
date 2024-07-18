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
  $("#selectOrg").val("");

  getIssues("issues");

  function getIssues(githubService, repoOrgName) {
    try {
      const issueURL = "https://api.github.com/user/issues";
      const repoIssuesURL = "https://api.github.com/repos/" + "{!! Auth::User()->nickname !!}" + "/" +repoOrgName+ "/issues";
      const orgIssueURL = "https://api.github.com/orgs/" +repoOrgName+ "/issues";
      const orgRepoIssueURL = "https://api.github.com/repos/" +repoOrgName+ "/issues";

      $.ajaxSetup({
        Headers,
      });
      $.ajax({
        beforeSend: function (xhr) {
          xhr.setRequestHeader("Authorization", "Bearer " + "{!! Auth::User()->github_token !!}");
        },
        url: githubService === "repo" ? repoIssuesURL : githubService === "org" ? orgIssueURL : githubService === "orgRepo" ? orgRepoIssueURL : issueURL,
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
                  <td class="flex justify-center items-start py-3"><a href="/repos/`+ (githubService === "repo" ? `n/` + repoOrgName : githubService === "org" ? repoOrgName + `/` + issue.repository.name : githubService === "orgRepo" ? repoOrgName : `n/` + issue.repository.name) + `/issues/` + issue.number + `" class="text-blue-700 underline flex" title="See datails">`+issue.number+`
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

  function addSelectForOrgRepos(orgName) {
    try {
      $.ajaxSetup({
        Headers,
      });
      $.ajax({
        beforeSend: function (xhr) {
          xhr.setRequestHeader("Authorization", "Bearer " + "{!! Auth::User()->github_token !!}");
        },
        url: "https://api.github.com/orgs/" + orgName + "/repos",
        type: "GET",
        dataType: "json",
        success: (response) => {
          const parentDiv = $("#selOrgRepo");
          parentDiv.empty();
          let orgRepoData = "";
          if (response.length > 0) {
            orgRepoData += `
              <select name="" id="orgRepos" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md block w-full p-2.5 ml-10">
                <option value="">Select `+orgName+` repo</option>
              `;
              $.each(response, (i, repo) => {
                orgRepoData += `
                  <option value="`+repo.full_name+`">`+repo.name+`</option>
                `;
              });
            orgRepoData += `
              </select>
            `;
            
            parentDiv.append(orgRepoData);
          }
        },
        error: (error) => {
          console.log(error)
        }
      });
    } catch (error) {
      console.log(error)
    }

  }

  $("#selectRepo").on("change", function() {
    $("#selectOrg").val("");
    $("#orgRepos").val("");
    $("#orgRepos").remove();
    if($(this).val() === "") {
      getIssues("issues");
    } else {
      getIssues("repo", $(this).val());
    }
  });

  $("#selectOrg").on("change", function() {
    $("#selectRepo").val("");
    if($(this).val() === "") {
      getIssues("issues");
      $("#orgRepos").val("");
      $("#orgRepos").remove();
    } else {
      getIssues("org", $(this).val());
      addSelectForOrgRepos($(this).val());
    }
  });

  $(document).on("change", "#orgRepos", function() {
    if($(this).val() === "") {
      console.log("empty");
    } else {
      getIssues("orgRepo", $(this).val());
    }
  });
});

</script>