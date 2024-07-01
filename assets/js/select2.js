$(document).ready(function () {
  $("#addCategory").select2({
    placeholder: "Select a category",
    allowClear: true,
  });
  $("#user-type").select2({
    placeholder: "Select a user type",
    allowClear: true,
  });
  $("#addcollege").select2({
    placeholder: "Select a college",
    allowClear: true,
  });
  $("#addcourse").select2({
    placeholder: "Select a course",
    allowClear: true,
  });

  $("#addcollege").change(function () {
    var college = $(this).val();
    var courses = {
      "College of Agriculture": [
        "Bachelor of Science in Agribusiness (BSAb)",
        "Bachelor of Science in Agriculture (BSA)",
      ],
      "College of Arts and Social Sciences": [
        "Bachelor of Arts in Filipino (BAFil)",
        "Bachelor of Arts in Literature (BALit)",
        "Bachelor of Arts in Social Sciences (BASS)",
        "Bachelor of Science in Development Communication (BSDC)",
        "Bachelor of Science in Psychology (BSPsych)",
      ],
      "College of Business Administration and Accountancy": [
        "Bachelor of Science in Accountancy (BSAc)",
        "Bachelor of Science in Business Administration (BSBA)",
        "Bachelor of Science in Entrepreneurship (BSEntrep)",
        "Bachelor of Science in Management Accounting (BSMA)",
      ],
      "College of Education": [
        "Bachelor of Culture and Arts Education (BCAEd)",
        "Bachelor of Early Childhood Education (BECEd)",
        "Bachelor of Elementary Education (BEEd)",
        "Bachelor of Physical Education (BPEd)",
        "Bachelor of Secondary Education (BSEd)",
        "Bachelor of Technology and Livelihood Education (BTLEd)",
      ],
      "College of Engineering": [
        "Bachelor of Science in Agricultural and Biosystems Engineering (BSABE)",
        "Bachelor of Science in Civil Engineering (BSCE)",
        "Bachelor of Science in Information Technology (BSIT)",
        "Bachelor of Science in Meteorology (BSMet)",
      ],
      "College of Fisheries": ["Bachelor of Science in Fisheries (BSF)"],
      "College of Home Science and Industry": [
        "Bachelor of Science in Food Technology (BSFT)",
        "Bachelor of Science in Fashion and Textile Technology (BSFTT)",
        "Bachelor of Science in Hospitality Management (BSHM)",
        "Bachelor of Science in Tourism Management (BSTM)",
      ],
      "College of Science": [
        "Bachelor of Science in Biology (BSBio)",
        "Bachelor of Science in Chemistry (BSChem)",
        "Bachelor of Science in Environmental Science (BSES)",
        "Bachelor of Science in Mathematics (BSMath)",
        "Bachelor of Science in Statistics (BSStat)",
      ],
      "College of Veterinary Science and Medicine": [
        "Doctor of Veterinary Medicine (DVM)",
      ],
      "Doctor of Philosophy": [
        "Doctor of Philosophy",
        "Doctor of Philosophy in Agricultural Engineering",
        "Doctor of Philosophy in Agricultural Entomology",
        "Doctor of Philosophy in Animal Science",
        "Doctor of Philosophy in Aquaculture",
        "Doctor of Philosophy in Biology",
        "Doctor of Philosophy in Crop Science",
        "Doctor of Philosophy in Development Communication",
        "Doctor of Philosophy in Development Education",
        "Doctor of Philosophy in Environmental Management",
        "Doctor of Philosophy in Plant Breeding",
        "Doctor of Philosophy in Rural Development",
        "Doctor of Philosophy in Soil Science",
        "Doctor of Philosophy in Sustainable Food Systems by Research Program (DOTUni)",
      ],
      "Master of Science": [
        "Master of Science in Agricultural Economics",
        "Master of Science in Agricultural Engineering",
        "Master of Science in Animal Science",
        "Master of Science in Aquaculture",
        "Master of Science in Biology",
        "Master of Science in Biology Education",
        "Master of Science in Chemistry Education",
        "Master of Science in Crop Protection",
        "Master of Science in Crop Science",
        "Master of Science in Development Communication",
        "Master of Science in Education",
        "Master of Science in Environmental Management",
        "Master of Science in Grain Science",
        "Master of Science in Guidance and Counselling",
        "Master of Science in Rural Development",
        "Master of Science in Soil Science",
      ],
      "Other Masteral Programs": [
        "Master of Arts in Language and Literature",
        "Master of Science in Renewable Energy Systems (DOTUni)",
        "Master of Veterinary Studies",
        "Master in Agribusiness Management",
        "Master in Biology",
        "Master in Business Administration",
        "Master in Chemistry",
        "Master in Environmental Management (DOTUni)",
        "Master in Local Government Management (DOTUni)",
      ],
      "Distance, Open, and Transnational University (DOTUni)": [
        "Diploma in Land Use Planning",
        "Diploma in Local Government Management",
        "Certificate in Agricultural Research Management",
        "Certificate in Basic Environmental Impact Assessment",
        "Certificate in Basic Local Governance",
        "Certificate in Entrepreneurship",
        "Certificate in Local Development Planning",
        "Certificate in Project Feasibility Preparation and Implementation",
        "Certificate in Training Management",
        "Certificate in Teaching",
      ],
      "Institute of Sports, Physical Education and Recreation": [
        "Certificate in Physical Education",
      ],
      "Vocational Course (1-Year Program)": [
        "Certificate in Agricultural Mechanics",
      ],
    };

    var courseOptions = '<option value="">Select a course</option>';
    if (college in courses) {
      $.each(courses[college], function (index, value) {
        courseOptions += '<option value="' + value + '">' + value + "</option>";
      });
    }
    $("#addcourse").html(courseOptions).trigger("change");
  });
});
