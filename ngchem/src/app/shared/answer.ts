export class Answer {
  state_id: number; //from states table
  answer: string; //given by student
  correct: string; //descriptive string, such as correct, close, formatError, etc
  timeStamp: number; //time when reply entered
  rt: number; //difference between time entered and question posted
  message: string; //message displayed
}
