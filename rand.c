#include<stdio.h>
#include<stdlib.h>
#include<time.h>

#define maxn 30
#define maxm 40

int map[maxn][maxm];

void get_map()
{
	for(int i=0; i<maxn; i++){
		for(int j=0; j<maxm; j++){
			scanf("%d",&map[i][j]);
		}
	}
}

void solve()
{
    
}

int main()
{
	get_map();
	srand((unsigned)time(NULL));
	printf("%d",rand()%4);
	return 0;
}