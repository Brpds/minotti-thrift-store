<template>
    <div class="container mb-3">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-capitalize">{{ cardName }}</div>
                    <div class="card-body">
                        <div class="row">
                            <slot name="content">

                            </slot>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props:['cardName'],
}
</script>

<style>

</style>