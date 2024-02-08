module.exports = {
    devServer: {
      proxy: {
        '^/Jeu': {
          target: 'http://docketu.iutnc.univ-lorraine.fr:50010',
          ws: true,
          changeOrigin: true
        },
      }
    }
  }
  