<template>
    <div>
        <input 
            id="wyswygEditor"
            :value="value"
            type="hidden">

        <trix-editor
            ref="wyswygEditor"
            input="wyswygEditor"
            placeholder="Type Here.."
            ></trix-editor>
    </div>
</template>

<script>
import Trix from 'trix'
export default {
    props: ['value'],
    mounted () {
        this.$refs.wyswygEditor.addEventListener('trix-change', e => {
            this.$emit('input', e.target.innerHTML)
        })
    }
}
</script>

<style lang="scss">
    @import "~trix/dist/trix.css";

    trix-editor {
        height: 250px;
        overflow: auto;
    }

    .trix-button--icon-increase-nesting-level,
    .trix-button--icon-heading-1,
    .trix-button--icon-quote,
    .trix-button--icon-code,
    .trix-button-group--file-tools,
    .trix-button--icon-decrease-nesting-level { display: none!important; }
</style>