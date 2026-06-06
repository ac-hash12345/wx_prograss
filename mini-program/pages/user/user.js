const app = getApp()
Page({
  data: {
    userInfo: null,
    hasUserInfo: false
  },
  onShow: function() {
    let userInfo = wx.getStorageSync('userInfo')
    if (userInfo) {
      this.setData({ userInfo, hasUserInfo: true })
    }
  },
  getUserProfile: function() {
    wx.getUserProfile({
      desc: '用于完善会员资料',
      success: (res) => {
        let profile = res.userInfo
        wx.login({
          success: loginRes => {
            if (loginRes.code) {
              wx.request({
                url: app.globalData.baseUrl + '/login.php',
                method: 'POST',
                data: {
                  openid: 'mock_openid_' + loginRes.code, // In real world use WeChat auth api
                  nickname: profile.nickName,
                  avatar: profile.avatarUrl
                },
                success: apiRes => {
                  if (apiRes.data.code == 200) {
                    wx.setStorageSync('userInfo', apiRes.data.data)
                    this.setData({ userInfo: apiRes.data.data, hasUserInfo: true })
                  }
                }
              })
            }
          }
        })
      }
    })
  },
  logout: function() {
    wx.removeStorageSync('userInfo')
    this.setData({ userInfo: null, hasUserInfo: false })
  }
})
