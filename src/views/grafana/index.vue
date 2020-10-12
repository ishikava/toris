<template>
  <div id="app">
    <div id="editor" ref="editor">Рассмотреть вариант использования графаны для мониторинга и алертинга</div>
    <div id="iframe-wrapper" :style="iframe.wrapperStyle">
      <iframe v-if="loaded" :src="iframe.src" :style="iframe.style" :height="iframe.style.height"
              :width="iframe.style.width" frameborder="0"></iframe>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      loaded: false,
      iframe: {
        src: 'https://play.grafana.org/d/000000012/grafana-play-home?orgId=1&from=now-24h&to=now&refresh=5s',
        style: null,
        wrapperStyle: null,
      }
    }
  },
  mounted() {
    let editor = this.$refs.editor;
    this.iframe.style = {
      position: 'absolute',
      width: window.innerWidth,
      height: window.innerHeight,
      top: -editor.offsetTop + "px",
      left: -editor.offsetLeft + "px",
    }
    this.iframe.wrapperStyle = {
      overflow: 'hidden',
      height: editor.clientHeight + "px",
      width: editor.clientWidth + "px",
    }
    this.loaded = true;
  }
}
</script>

<style lang="scss" scoped>

</style>
