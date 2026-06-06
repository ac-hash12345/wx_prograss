const app = getApp()

Page({
  data: {
    goodsList: []
  },
  onLoad: function () {
    this.getGoodsList()
  },
  onPullDownRefresh: function() {
    this.getGoodsList()
    wx.stopPullDownRefresh()
  },
  getGoodsList: function() {
    wx.request({
      url: app.globalData.baseUrl + '/goods.php?action=list',
      success: res => {
        if (res.data && res.data.code == 200) {
          this.setData({ goodsList: res.data.data })
        }
      }
    })
  }
})
