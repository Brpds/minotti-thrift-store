@extends('layouts.app')

@section('content')

    <maincard-component card-name="Avaliações">
        <template v-slot:content>
            <avaliacoes-component>
            </avaliacoes-component>
        </template>
    </maincard-component>

@endsection