import _ from "lodash";
export default {
  install: function (Vue) {

    //produces a string of given length; increasing zeros increases probability
    //that any given digit in string is zero
    Vue.bondPositioner = function(textRect, direction) {
      let bondLength = 20
      let start = [0,0]
      let end=[20,20]
      let height = textRect.height
      let width = textRect.width
      if (direction === 0) {
        start = [textRect.left - 5,textRect.centery]
        end = [start[0] - bondLength, start[1]]
      }
      if (direction === 6) {
        start = [textRect.right +5, textRect.centery]
        end = [start[0] + bondLength, start[1]]
      }
      if (direction === 3) {
        start = [textRect.centerx, textRect.top -5]
        end = [start[0], start[1]-bondLength]
      }
      if (direction === 9) {
        start = [textRect.centerx, textRect.bottom]
        end = [start[0], start[1]+bondLength]
      }
      if (direction === 1) {
        start = [textRect.left -4, textRect.centery-height/3]
        end = [start[0] - bondLength*0.866, start[1]-bondLength/2]
      }
      if (direction === 11) {
        start = [textRect.left -4, textRect.centery+height/3]
        end = [start[0] - bondLength*0.866, start[1]+bondLength/2]
      }
      if (direction === 5) {
        start = [textRect.right +3, textRect.centery-height/3]
        end = [start[0] + bondLength*0.866, start[1]-bondLength/2]
      }
      if (direction === 7) {
        start = [textRect.right+3, textRect.centery+height/3]
        end = [start[0] + bondLength*0.866, start[1]+bondLength/2]
      }
      if (direction === 2) {
        start = [textRect.centerx - width/3, textRect.top-3]
        end = [start[0] - bondLength/2, start[1]-bondLength*0.866]
      }
      if (direction === 10) {
        start = [textRect.centerx - width/3, textRect.bottom]
        end = [start[0] - bondLength/2, start[1]+bondLength*0.866]
      }
      if (direction === 4) {
        start = [textRect.centerx + width/3, textRect.top-3]
        end = [start[0]+ bondLength/2, start[1]-bondLength*0.866]
      }
      if (direction === 8) {
        start = [textRect.centerx + width/3, textRect.bottom]
        end = [start[0]+ bondLength/2, start[1]+bondLength*0.866]
      }

      return {start: start, end: end}
  }
  Vue.newAtomPositioner = function(textRect, direction) {
    let bondLength = 30;
    let end = [0,0]
    let start =[20,20]
    let height = textRect.height
    let width = textRect.width
    if (direction === 0) {
      start = [textRect.left - 5,textRect.centery]
      end = [start[0] - bondLength, start[1]]
    }
    if (direction === 6) {
      start = [textRect.right +5, textRect.centery]
      end = [start[0] + bondLength, start[1]]
    }
    if (direction === 3) {
      start = [textRect.centerx, textRect.top -5]
      end = [start[0], start[1]-bondLength]
    }
    if (direction === 9) {
      start = [textRect.centerx, textRect.bottom]
      end = [start[0], start[1]+bondLength]
    }
    if (direction === 1) {
      start = [textRect.left -4, textRect.centery-height/3]
      end = [start[0] - bondLength*0.866, start[1]-bondLength/2]
    }
    if (direction == 11) {
      start = [textRect.left -4, textRect.centery+height/3]
      end = [start[0] - bondLength*0.866, start[1]+bondLength/2]
    }
    if (direction === 5) {
      start = [textRect.right +3, textRect.centery-height/3]
      end = [start[0] + bondLength*0.866, start[1]-bondLength/2]
    }
    if (direction === 7) {
      start = [textRect.right+3, textRect.centery+height/3]
      end = [start[0] + bondLength*0.866, start[1]+bondLength/2]
    }
    if (direction === 2) {
      start = [textRect.centerx - width/3, textRect.top-3]
      end = [start[0] - bondLength/2, start[1]-bondLength*0.866]
    }
    if (direction === 10) {
      start = [textRect.centerx - width/3, textRect.bottom]
      end = [start[0] - bondLength/2, start[1]+bondLength*0.866]
    }
    if (direction == 4) {
      start = [textRect.centerx + width/3, textRect.top-3]
      end = [start[0]+ bondLength/2, start[1]-bondLength*0.866]
    }
    if (direction === 8) {
      start = [textRect.centerx + width/3, textRect.bottom]
      end = [start[0]+ bondLength/2, start[1]+bondLength*0.866]
    }
    return end
  }



}
