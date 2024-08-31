document.getElementById("table-gridjs") && new gridjs.Grid({
    columns: [
        {
            name: "ID",
            width: "80px",
            formatter: function (e) {
                return gridjs.html('<span class="fw-semibold">' + e + "</span>")
            }
        },
        { name: "Name", width: "150px" },
        {
            name: "Email", width: "220px", formatter: function (e) {
                return gridjs.html('<a href="">' + e + "</a>")
            }
        },
        { name: "Position", width: "250px" },
        { name: "Company", width: "180px" },
        { name: "Country", width: "180px" },
        {
            name: "Actions", width: "150px", formatter: function (e) {
                return gridjs.html("<a href='#' class='text-reset text-decoration-underline'>Details</a>")
            }
        }],
    pagination: { limit: 5 },
    sort: !0,
    search: !0,
    data: [
        ["01", "Jonathan", "jonathan@example.com", "Senior Implementation Architect", "Hauck Inc", "Holy See"],
        ["02", "Harold", "harold@example.com", "Forward Creative Coordinator", "Metz Inc", "Iran"],
        ["03", "Shannon", "shannon@example.com", "Legacy Functionality Associate", "Zemlak Group", "South Georgia"],
        ["04", "Robert", "robert@example.com", "Product Accounts Technician", "Hoeger", "San Marino"],
        ["05", "Noel", "noel@example.com", "Customer Data Director", "Howell - Rippin", "Germany"],
        ["06", "Traci", "traci@example.com", "Corporate Identity Director", "Koelpin - Goldner", "Vanuatu"],
        ["07", "Kerry", "kerry@example.com", "Lead Applications Associate", "Feeney, Langworth and Tremblay", "Niger"],
        ["08", "Patsy", "patsy@example.com", "Dynamic Assurance Director", "Streich Group", "Niue"],
        ["09", "Cathy", "cathy@example.com", "Customer Data Director", "Ebert, Schamberger and Johnston", "Mexico"],
        ["10", "Tyrone", "tyrone@example.com", "Senior Response Liaison", "Raynor, Rolfson and Daugherty", "Qatar"]
    ]
}).render(document.getElementById("table - gridjs"))
