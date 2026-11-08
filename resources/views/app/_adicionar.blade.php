@extends('layouts.app')

@section('content')

    <mainCard-component card-name="Adição de Item:">
        <template v-slot:content>
            <spa-component></spa-component>
        </template>
    </mainCard-component>

@endsection