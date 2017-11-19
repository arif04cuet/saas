{{ content() }}

<div class="center scaffold">
    <h2>Forms List</h2>

{% for formspay in formspay %}
{% if loop.first %}
<table class="table table-bordered table-striped" align="center">
    <thead>
        <tr>
            <th>Id</th>
            <th>Applicant Name</th>
            <th>Type</th>
            <th>Actions</th>
        </tr>
    </thead>
    {% endif %}

    <?php
    $type = $formspay->form_name;
    $form_fields_arr = unserialize($formspay->form_fields);
    if($type == "paycom_individual")
    {
        $type_title = "ব্যক্তি পর্যায়ে জরিপ";

        foreach ($form_fields_arr as $Key => $Value)
        {
            $applicant_name = "";
             if($Key == "name_applicant")
             {
                $applicant_name = $Value;
                break;
             }
        }
    }
    else
    {
        $type_title = "ইন্সস্টিটিউট পর্যায়ে জরিপ";
        foreach ($form_fields_arr as $Key => $Value)
        {
            $applicant_name = "";
             if($Key == "org_name")
             {
                $applicant_name = $Value;
                break;
             }
        }
    }

    ?>

    <tbody>
    <tr>
        <td>{{ formspay.id }}</td>
        <td><?php echo $applicant_name; ?></td>
        <td><?php echo $type_title; ?></td>
        <td width="">
            {{ link_to("formspay/show/" ~ formspay.id, '<i class="icon-pencil"></i>', "class": "btn") }}
            {{ link_to("formspay/delete/" ~ formspay.id, '<i class="icon-remove"></i>', "class": "btn") }}
        </td>
    </tr>
    </tbody>
    {% if loop.last %}
</table>
{% endif %}
{% else %}
No forms are recorded
{% endfor %}
</div>