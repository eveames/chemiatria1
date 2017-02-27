import { Injectable } from '@angular/core';

@Injectable()
export class RandomService {

  constructor() { }

  getRandomDigit(max: number, min: number): number {
        return Math.floor(Math.random()* (max-min)) + min;
      }
  //gets a string of random digits, where probability of 0 is increased by zeros
  getRandomString(length: number, zeros: number): string {
        let randomString: string = '';
        let min, max: number;
        if (zeros === 0) {
         min = 1;
         max = 10;
        }
        else {
         min = 0;
         max = 10 + zeros;
        }
        for(let i: number =0; i < length; i++) {
         let newDigit: number = this.getRandomDigit(max, min);
         if (newDigit > 9) {newDigit = 0;}
          randomString += newDigit;
        }
        return randomString;
      }
      getRandomExclude(max: number,excludeNum: number): number {
        let randNumber: number = Math.floor(Math.random() * max);
        if(randNumber === excludeNum) {
          return this.getRandomExclude(max,excludeNum);
        }else{
          return randNumber;
        }
      }
      getRandomNear(max: number,excludeNum: number, maxSeparation: number) {
        let randNumber: number = Math.floor(Math.random() * max);
        if(randNumber === excludeNum) {
          return this.getRandomNear(max,excludeNum, maxSeparation);
        }
        else if (randNumber - excludeNum > maxSeparation || randNumber - excludeNum < -1 * maxSeparation) {
          return this.getRandomNear(max,excludeNum, maxSeparation);
        }
        else{
          return randNumber;
        }
      }
}
