<template>
    <a :href="routeName" class="col-xl-3 col-sm-6 col-12 mt-2"  style="text-decoration: none; font-weight: bold; font-size: large;">
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <div class="media d-flex">
                <div class="align-self-center">
                  <i class="icon-speech warning font-large-2 float-left"></i>
                </div>
                <div class="media-body text-right">
                  <span :class="implemented ? 'text-danger' : 'text-success'">{{ cardName }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
    </a>
</template>

<script>

export default {
    props:[
        'cardName',
        'routeName',
        'implemented'
    ],
    data(){
      return {
      }
    },
    methods:{
    },
}
</script>

<style>

</style>