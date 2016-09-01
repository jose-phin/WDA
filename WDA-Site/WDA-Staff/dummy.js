$(document).ready(function() {

    var dummyData = [

        {
            "user": {
                "firstName": "George",
                "lastName": "Clooney",
                "email": "ladies_man@hotmail.com"
            },
            "ticket": {
                "osType": "macOS",
                "subject": "Software",
                "primaryIssue": "Can't login to Blackboard",
                "additionalNotes": "Blackboard sux"
            }
        },
        {
            "user": {
                "firstName": "Lizard",
                "lastName": "Queen",
                "email": "SssSSsssSS01@hotmail.com"
            },
            "ticket": {
                "osType": "Linux",
                "subject": "Software",
                "primaryIssue": "Need money for food",
                "additionalNotes": "Blackboard sux"
            }         
        },
        {
            "user": {
                "firstName": "Jennifer",
                "lastName": "Aniston",
                "email": "freindz_4eva@mail.com"
            },
            "ticket": {
                "osType": "Windows",
                "subject": "Google Mail",
                "primaryIssue": "Forgot GMail password",
            }         
        }

    ]

    var rowNum = 1;

    for (var i = 0; i < dummyData.length; i++) {

        var tableRow = "<tr data-toggle=\"collapse\" class=\"accordion-toggle\">";
        var rowNumString = "<td>" + rowNum.toString() + "</td>";
        var name = dummyData[i]["user"].firstName + " " + dummyData[i]["user"].lastName;
        var email = dummyData[i]["user"].email;
        var os = "<td>" + dummyData[i]["ticket"].osType + "</td>";
        var subject = "<td>" + dummyData[i]["ticket"].subject + "</td>";
        var primaryIssue  = "<td><span class=\"ticket-name\">" + dummyData[i]["ticket"].primaryIssue + "<br></span>" + 
                            "<span class=\"small\">" + name + " (" + email + ")</span></td>";
        var additionalNotes  = "<td>" + dummyData[i]["ticket"].additionalNotes + "</td>";
        var status = "<td><span class=\"status status-pending\">Pending</span></td>"; /* Static */
        var tableRowEnd = "</tr>";

        $("#table-body").append(tableRow + rowNumString + primaryIssue + status + subject + os + tableRowEnd);
        rowNum++;

    }

});