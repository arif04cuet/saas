{{ content() }}

<div class="center scaffold">

    <ul>
{% for contentType in contentTypes %}
        <?php //var_dump($contentType)?>
        <?php $icon = $contentType->icon?$contentType->icon:"icon-th-large"; ?>
        <li class="box span2">{{ link_to("content/" ~ contentType.name, '<i class="'~icon~'"></i> <span>'~contentType.human_name~'</span>', "class": "") }}</li>

    {% if loop.first %}
    {% endif %}
    {% if loop.last %}
{% endif %}
{% else %}
No content types are recorded
{% endfor %}
    </ul>
</div>
    <style>
        .box {
            background-color: #EEEEEE;
            list-style: none outside none;
            padding: 5px;
            margin: 5px;
            text-align: center;
            height: 90px;
        }
        .box:hover {
            background-color: #ccc;
        }
        .box a {
            display: inline-block;
            height: 90px;
            width: 100%;
        }
        .box a:hover {
            color: #33485D;
            text-decoration: none;
        }
        .box a span{
            margin-top: 5px;
            width: 100%;
            float: left;
            font-weight: bold;
            font-size: 1.1em;
        }
        .box i{
            font-size: 4em;
            line-height: 1em;
            width: 100%;
        }
    </style>

