<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>De beste pokedex app!</title>
</head>
<body>
    <main>
        {{$pokemon->name}}
        @foreach ($pokemon->types as $type)
        <b>
            {{$type["type"]["name"]}}
        </b>

        @endforeach

        @foreach ($pokemon->moves as $move)
            @if ($move['version_group_details'][0]["move_learn_method"] === 'level-up' && $move['version_group_details'][0]["version_group"] === 'red-blue')
                <p>move: {{$move['move']}}, learned at: {{$move['version_group_details'][0]["level_learned_at"]}}</p>
            @endif
        @endforeach
    </main>
</body>
</html>