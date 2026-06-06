const app = getApp()
Page({
  data: {
    goods: {}
  },
  onLoad: function (options) {
    if (options.id) {
      this.getGoodsDetail(options.id)
    }
  },
  getGoodsDetail: function(id) {
    wx.request({
      url: app.globalData.baseUrl + '/goods.php?action=detail&id=' + id,
      success: res => {
        if (res.data && res.data.code == 200) {
          this.setData({ goods: res.data.data })
        }
      }
    })
  },
  addCart: function() {
    let cart = wx.getStorageSync('cart') || []
    let goods = this.data.goods
    let exist = cart.find(item => item.id == goods.id)
    if (exist) {
      exist.num += 1
    } else {
      goods.num = 1
      cart.push(goods)
    }
    wx.setStorageSync('cart', cart)
    wx.showToast({ title: '已加入购物车' })
  },
  buyNow: function() {
    this.addCart()
    wx.switchTab({ url: '/pages/cart/cart' })
  }
})
