const app = getApp()
Page({
  data: {
    orders: [],
    statusMap: ['待付款', '待发货', '已发货', '已完成']
  },
  onShow: function () {
    let userInfo = wx.getStorageSync('userInfo')
    if (userInfo) {
      this.getOrders(userInfo.id)
    } else {
      wx.switchTab({ url: '/pages/user/user' })
    }
  },
  getOrders: function(userId) {
    wx.request({
      url: app.globalData.baseUrl + '/order.php?action=list&user_id=' + userId,
      success: res => {
        if (res.data.code == 200) {
          this.setData({ orders: res.data.data })
        }
      }
    })
  }
})
