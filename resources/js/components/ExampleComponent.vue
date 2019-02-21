<template>
    <div class="row">
       <legend>Indicadores</legend>
       <button></button>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        {{indicadores}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data:()=>({
            indicadores:'XDXD'
        }),
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
