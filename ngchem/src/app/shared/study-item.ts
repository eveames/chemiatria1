export class StudyItem {

//state_id is id in states table
//type is a reference to word (1), fact(2) or skill(3)
//type_id is a reference to id in words,facts or skills table
//priority is the unix time when should be studied again, or small int if new
//stage is how well known it is
//accs is an array of how many tries it took you to get it right
//rts is an array of response times (only for last/correct attempt each time)
  constructor(public state_id: number, public type: number, public type_id: number,
    public priority: number, public stage: number, public accs: number[],
    public rts: number[]) {}
}
