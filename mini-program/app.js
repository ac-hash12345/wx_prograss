App({
  onLaunch: function () {
    let userInfo = wx.getStorageSync('userInfo')
    if (userInfo) {
      this.globalData.userInfo = userInfo
    }
  },
  globalData: {
    userInfo: null,
    baseUrl: 'http://localhost/backend/api'
  }
})
