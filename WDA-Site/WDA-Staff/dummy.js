$(document).ready(function() {

    console.log("Entered JavaScript!");

    var dummyData = [

        {
            "user": {
                "firstName": "George",
                "lastName": "Clooney",
                "email": "georgio.cloonio@gmail.com"
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
                "email": "xXx_Slytherinz_xXx@hotmail.com"
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
                "email": "hot_frendz_69@mail.com"
            },
            "ticket": {
                "osType": "Windows",
                "subject": "Google Mail",
                "primaryIssue": "Forgot GMail password",
            }         
        }

    ]

    for (var i = 0; i < dummyData.length; i++) {

        var tableRow = "<tr data-toggle=\"collapse\" class=\"accordion-toggle\">";

        // Name
        if (dummyData[i]["user"].firstName != "" || dummyData[i]["user"].lastName != "") {
            var tableName = "<td>" + dummyData[i]["user"].firstName + " " + dummyData[i]["user"].lastName + "</td>";
        }
       
        // Email
        var tableEmail = "<td><span class=\"small\">" + dummyData[i]["user"].email + "</td>";

        // OS
        var tableOS = "<td>" + dummyData[i]["ticket"].osType + "</td>";

        // Subject
        var tableSubject = "<td>" + dummyData[i]["ticket"].subject + "</td>";
       
        // Primary Issue
        var tablePrimaryIssue  = "<td><span class=\"ticket-name\">" + dummyData[i]["ticket"].primaryIssue + "</span></td>";

        // Additional notes
        if (dummyData[i]["ticket"].additionalNotes != "") {
            var tableAdditionalNotes  = "<td>" + dummyData[i]["ticket"].additionalNotes + "</td>";
        }

        // Status [STATIC]
        var tableStatus = "<td><span class=\"status status-pending\">Pending</span></td>";

        // Date [STATIC]
        var tableDate = "<td>Aug 31, 2016</td>"

        var tableRowEnd = "</tr>";

        $("#table-body").append(tableRow + tableName + tablePrimaryIssue + tableStatus + tableSubject + tableOS + tableDate + tableRowEnd);
    }

});