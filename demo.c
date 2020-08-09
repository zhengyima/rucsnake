#include<stdio.h>
#include<stdlib.h>
#include<time.h>

#define INF 10000    
#define maxn 30
#define maxm 40
#define threshold 6

//�������Ӧ��ѧ��Ϊ2019101404
//�ִ���ɣ������������ߣ������ο� 

int judgeifHead(int value)//�ж�һ�����ӵ���ֵ�Ƿ���ͷ
{ 
	if(value >= 94040 && value <= 94043){return 1;}
	int negvalue = -value;
	if(negvalue >= 940400 && value <= 940402){return 1;}
	if(negvalue >= 940410 && value <= 940412){return 1;}
	if(negvalue >= 940420 && value <= 940422){return 1;}
	if(negvalue >= 940430 && value <= 940432){return 1;}
	return 0;
}

int judgedirection(int value)//�ж�ͷ�ķ���
{ 
	if(value >= 94040 && value <= 94043){return value-70840;}
	int negvalue = -value;
	if(negvalue >= 940400 && value <= 940402){return value/10-94040;}
	if(negvalue >= 940410 && value <= 940412){return value/10-94040;}
	if(negvalue >= 940420 && value <= 940422){return value/10-94040;}
	if(negvalue >= 940430 && value <= 940432){return value/10-94040;}
	return 0;
}

int judgeifBozi(int value)//�ж�һ�����ӵ���ֵ�Ƿ��ǲ��� 
{
	if(value >= 19114040 && value <=  19114049){return 1;}
	if(value >=  191140410 && value <=  191140499){return 1;}
	return 0;
} 

int judgeifBody(int value)//�ж�һ�������Ƿ�������
{
	if(value ==1911404) return 1;
	else return 0;
}

int judgeother(int value)//�ж�һ�������Ƿ��Ǳ���ߵ�����
{
	if(value >= 60000){
		return 1;
	}else{
		return 0;
	}
}

//�������Ӧ��ѧ��Ϊ2019101404

int judgeDaojuNums(int value)////�жϵ�ǰӵ�ж��ٵ��� 
{
	if(value >=  19114040 && value <=  19114049){return value % 10;}
	if(value >=  191140410 && value <=  191140499){return 9;} //͵���ˣ�����9һ�ɰ�9����
	return 0;
}

int judge(int * map)//���㷨ʵ���˲�����Ϊײǽ����������ӵ���������߱����Է�һ�ε��ߡ� 
{
	//һ��40��
	//������ͷ�����ӣ����� 
	int head_idx = -1, bozi_idx = -1, des = -1, daoju_nums = -1; //ͷλ�ã�����λ�ã����򣬵�������
	for(int i=0; i< 30*40; i++){
		if(judgeifHead(map[i])){ //�˸��Ƿ�Ϊͷ? 
			head_idx = i;
			if(map[i] > 0){des = map[i] % 10; }
			else{des = (-map[i]) /10%10;}
		}
		if(judgeifBozi(map[i])){bozi_idx = i;}//�˸��Ƿ�Ϊ���� 
	}
	daoju_nums = judgeDaojuNums(map[bozi_idx]); //���ݲ��ӵ���ֵ��õ������� 
	if(daoju_nums >= 2){return 4;}//���ӵ�еĵ��߳���������ֱ�ӷŵ��ߡ� 

	//printf("%d %d %d\n",head_idx,bozi_idx, des);
	int cannotgo[4] = {0}; //ʹ���ų�������¼��Щ�������ߡ� 
	if ((head_idx >= 0 && head_idx < 40) || des == 3){cannotgo[1] = 1;  }//��ǽ�����ʱ�������ߣ�����������
	if((head_idx >= 40 * 29 && head_idx < 40 * 30 ) || des == 1) {cannotgo[3] = 1; }////��ǽ�����ʱ�������ߣ����������� 
	if ((head_idx % 40 == 0) || des == 2)  {cannotgo[0] = 1; }////��ǽ�����ʱ�������ߣ�����������
	if((head_idx % 39 == 0 && head_idx > 0) || des == 0)  {cannotgo[2] = 1; } ////��ǽ�����ʱ�������� ������������
	
	for(int i=0; i<4; i++) //ѡһ�����ߵķ����� 
	{
		if(!cannotgo[i]) return i;
	}
	return 0;//�ĸ����򶼲����ߣ��Ǿ������һ��0�ɣ������ټ���
}

int main()
{
	int a[1200]; //�洢��ͼ
	for(int i = 0; i<1200; i++){
		scanf("%d",&a[i]); //�����ͼ 
		// if(judgeifHead(a[i])){
		// 	printf("%d\n",i);
		// }
		// if(judgeifBozi(a[i])){
		// 	printf("%d\n",i);
		// }
	}
	 
	int des = judge(a); //����㷨���������һ������des 
	printf("%d", des);
	return 0;
}
